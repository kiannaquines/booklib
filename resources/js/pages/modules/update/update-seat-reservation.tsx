import { useState } from 'react'
import AppLayout from '@/layouts/app-layout'
import { User, type BreadcrumbItem } from '@/types'
import { Head, useForm, router } from '@inertiajs/react'
import { toast } from 'sonner'
import { Button } from '@/components/ui/button'
import { ArrowLeft, FilePenLine, Loader2, RefreshCcw } from 'lucide-react'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Seat Reservation',
    href: route('seat-reservations.index'),
  },
]

type SeatReservation = {
  id: number
  seat: string
  user_id: number
  reason: string
}

type Spaces = {
  id: string
  status: string
  seat: string
}

type UpdateSeatReservationProps = {
  users: User[]
  spaces: Spaces[]
  reservation: SeatReservation
}

type SeatReservationFormData = {
  user_id: string
  seat: string
  reason: string
}

const UpdateSeatReservation = ({ users, spaces, reservation }: UpdateSeatReservationProps) => {
  const { data, setData, reset, clearErrors } = useForm<SeatReservationFormData>({
    seat: String(reservation.seat),
    user_id: String(reservation.user_id),
    reason: String(reservation.reason),
  })

  const [processing, setProcessing] = useState(false)

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    setProcessing(true)

    router.put(route('seat-reservations.update', { id: reservation.id }), data, {
      preserveScroll: true,
      onSuccess: () => {
        toast.success('Seat reservation updated successfully')
        setProcessing(false)
        reset()
      },
      onError: (errors) => {
        Object.values(errors).forEach((message) => {
          toast.error('Oops, please try again', {
            description: String(message),
          })
        })
        setProcessing(false)
      },
    })
  }

  const handleReset = () => {
    reset()
    clearErrors()
    toast.info('Form inputs reset.')
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Edit Seat Reservation" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="flex justify-between items-center mb-4">
          <Button variant="outline" onClick={() => router.visit(route('seat-reservations.index'))}>
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to Seat Reservation
          </Button>
        </div>

        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
          <div className="flex flex-col gap-1 mb-4">
            <h2 className="text-lg font-semibold">Edit Seat Reservation</h2>
            <p className="text-sm text-muted-foreground">Update the reservation details</p>
          </div>

          <form onSubmit={handleSubmit} method="POST">
            <div className="grid gap-4">
              {/* Reserved By */}
              <div className="flex flex-col space-y-1.5">
                <Label htmlFor="user_id">Reserved by</Label>
                <Select
                  value={String(data.user_id)}
                  onValueChange={(value) => setData('user_id', value)}
                >
                  <SelectTrigger id="user_id">
                    <SelectValue placeholder="Select user" />
                  </SelectTrigger>
                  <SelectContent>
                    {users.map((user) => (
                      <SelectItem key={user.id} value={String(user.id)}>
                        {user.name}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              {/* Seat */}
              <div className="flex flex-col space-y-1.5">
                <Label htmlFor="seat">Seat</Label>
                <Select
                  value={data.seat}
                  onValueChange={(value) => setData('seat', value)}
                >
                  <SelectTrigger id="seat">
                    <SelectValue placeholder="Select seat" />
                  </SelectTrigger>
                  <SelectContent>
                    {spaces.map((space) => (
                      <SelectItem key={space.id} value={String(space.id)}>
                        {space.status} - {space.seat}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              {/* Reason */}
              <div className="flex flex-col space-y-1.5">
                <Label htmlFor="reason">Reason</Label>
                <Textarea
                  id="reason"
                  name="reason"
                  value={data.reason}
                  onChange={(e) => setData('reason', e.target.value)}
                  placeholder="Type your reason here."
                />
              </div>
            </div>

            <div className="flex items-center gap-4 mt-6">
              <Button type="submit" disabled={processing}>
                {processing ? (
                  <Loader2 className="w-4 h-4 mr-2 animate-spin" />
                ) : (
                  <FilePenLine className="w-4 h-4 mr-2" />
                )}
                Update Seat Reservation
              </Button>
              <Button type="button" variant="outline" onClick={handleReset}>
                <RefreshCcw className="w-4 h-4 mr-2" />
                Reset
              </Button>
            </div>
          </form>
        </div>
      </div>
    </AppLayout>
  )
}

export default UpdateSeatReservation